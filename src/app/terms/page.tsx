"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import Terms from "@/pages/Terms";

export default function TermsPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <Terms />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 